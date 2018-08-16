<?php

class Good
{
    public $redis = null;

    // 60*60*24/20=4320,每个点赞得到的分数
    public $score = 4320;

    // 点赞增加数,或者点hate增加数
    public $num = 1;

    // init redis
    public $redis_host = "127.0.0.1";
    public $redis_port = "6379";
    public $redis_pass = "123456";

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect($this->redis_host, $this->redis_port);
        $this->redis->auth($this->redis_pass);
    }

    /**
     * @param int $user_id 用户id
     * @param int $type 点击的类型 1.点like,2.点hate
     * @param int $comment_id 文章id
     * @return string json
     */
    public function click($user_id, $type, $comment_id)
    {
        // 判断redis是否已经缓存了该文章数据
        // 使用 : 分隔符对redis管理是友好的
        // 这里使用redis zset->zscore()方法
        if ($this->redis->zScore("comment:like", $comment_id))
        {
            // 已经存在
            // 判断点是什么
            if (1 == $type)
            {
                // 判断以前是否点过,点的是什么?
                // redis hash->hGet()
                $rel = $this->redis->hGet("comment_record", $user_id.":".$comment_id);
                if (!$rel)
                {
                    // 什么都没点过
                    // 点赞加1
                    $this->redis->zIncrBy("comment:like", $this->num, $comment_id);
                    // 增加分数
                    $this->redis->zIncrBy("comment:score", $this->score, $comment_id);
                    // 记录上次操作
                    $this->redis->hSet("comment:record", $user_id.":".$comment_id,$type);

                    $data = [
                        "state" => 1,
                        "status" => 200,
                        "msg" => "like add one"
                    ];
                }
                elseif ($rel == $type)
                {
                    // 点过赞了
                    // 点赞减1
                    $this->redis->zIncrBy("comment:like", -($this->num), $comment_id);
                    // 增加分数
                    $this->redis->zIncrBy("comment:score", -($this->score), $comment_id);
                    $data = [
                        "state" => 2,
                        "status" => 200,
                        "msg" => "like -1"
                    ];
                }
                elseif (2 == $rel)
                {
                    // 点过hate
                    // hate减1
                    $this->redis->zIncrBy("comment:hate", -($this->num), $comment_id);
                    // 增加分数
                    $this->redis->zIncrBy("comment:score", $this->score + $this->score, $comment_id);
                    // 点赞加1
                    $this->redis->zIncrBy("comment:like", $this->num, $comment_id);
                    // 记录上次操作
                    $this->redis->hSet("comment:record", $user_id.":".$comment_id, $type);

                    $data = [
                        "state" => 3,
                        "status" => 200,
                        "msg" => "like + 1"
                    ];
                }
            }
            elseif (2 == $type)
            {
                // 点hate和点赞的逻辑是一样的。参看上面的点赞
                $rel = $this->redis->hGet("comment:record", $user_id.":".$comment_id);
                if (!$rel)
                {
                    // 什么都没点过
                    // 点hate加1
                    $this->redis->zIncrBy("comment:hate", $this->num, $comment_id);
                    // 减分数
                    $this->redis->zIncrBy("comment:score", -($this->score), $comment_id);
                    // 记录上次操作
                    $this->redis->hSet("comment:record", $user_id.":".$comment_id,$type);

                    $data = [
                        "state" => 4,
                        "status" => 200,
                        "msg" => "hate + 1"
                    ];
                }
                elseif ($type == $rel)
                {
                    // 点过hate
                    // 点hate减1
                    $this->redis->zIncrBy("comment:hate", -($this->num), $comment_id);
                    // 增加分数
                    $this->redis->zIncrBy("comment:score", $this->score, $comment_id);

                    $data = [
                        "state" =>5,
                        "status" => 200,
                        "msg" => "hate - 1"
                    ];
                    return $data;
                }
                elseif (2 == $rel)
                {
                    // 点过like
                    // like减1
                    $this->redis->zIncrBy("comment:like",  -($this->num), $comment_id);
                    // 增加分数
                    $this->redis->zIncrBy("comment:score", -($this->score + $this->score), $comment_id);
                    // 点hate加1
                    $this->redis->zIncrBy("comment:hate", $this->num, $comment_id);

                    $data = [
                        "state" => 6,
                        "status" => 200,
                        "msg" => "hate + 1"
                    ];
                    return $data;
                }
            }
        }
        else
        {
            // 未存在
            if (1 == $type)
            {
                // 点赞加一
                $this->redis->zIncrBy("comment:like", $this->num, $comment_id);
                // 分数增加
                $this->redis->zIncrBy("comment:score", $this->score, $comment_id);
                $data = [
                    "state" => 7,
                    "status" => 200,
                    "msg" => "like+1"
                ];
            }
            elseif (2 == $type)
            {
                // 点hate加一
                $this->redis->zIncrBy("comment:hate", $this->num, $comment_id);
                // 分数减一
                $this->redis->zIncrBy("comment:score", -($this->score), $comment_id);

                $data = [
                    "state" => 8,
                    "status" => 200,
                    "msg" => "hate + 1"
                ];
            }
            // 记录
            $this->redis->hSet("comment:record",$user_id.":".$comment_id,$type);
        }

        // 判断是否需要更新数据
        $this->ifUploadList($comment_id);
        echo json_encode($data);
        return;
    }

    public function ifUploadList($comment_id)
    {
        $time = time();
        if (!$this->redis->sIsMember("comment:uploadset", $comment_id))
        {
            // 文章不存在集合里,需要更新
            $this->redis->sAdd("comment:uploadset", $comment_id);
            // 更新到队列
            $data = [
                "id" => $comment_id,
                "time" => $time
            ];
            $json = json_encode($data);
            $this->redis->lPush("comment:uploadlist", $json);
        }
    }
}

// 调用
$user_id = 100;
$type = 1;
$comment_id = 99;
$good = new Good();
$rel = $good->click($user_id, $type, $comment_id);