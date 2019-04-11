<?php class REMOVE_COMMENT
{
    var $path = " ";
    var $file = " ";
    var $content = " ";
    var $after_content = " ";
    var $compact_content = " ";
    var $reg_comment = " !((/\*)[\s\S]*?(\*/))|(//.*)! ";
    var $reg_space = "![ ]+!";
    var $reg_all_space = "!\s+!";
    var $file_info = array();
    var $alowed_type = array("php", "css", "c", "c++", "txt", "html", "htm", "tpl");
    var $save_file = " ";

    function __construct($path = "")
    {
        $this->load_file($path);
    }

    function load_file($path = "")
    {
        global $error;
        $this->free();
        if (!$path) {
            $this->halt($error[0]);
        } elseif (!file_exists($path)) {
            $this->halt($error[1]);
        } else {
            $this->path = $path;
            $this->open_file();
        }
    }

    protected function open_file()
    {
        global $error;
        if (!is_file($this->path)) {
            $this->halt($error[2]);
        } else {
            if (!is_readable($this->path)) {
                $this->halt($error[3]);
            } else {
                if (!($this->file = @fopen($this->path, "r"))) {
                    $this->halt($error[4]);
                } else {
                    $this->file_info = pathinfo($this->path);
                    if (in_array($this->file_info["extension"], $this->alowed_type)) {
                        $this->read_file();
                    } else {
                        $this->halt($error[2]);
                    }
                }
            }
        }
    }

    protected function read_file()
    {
        if (!$this->file) {
            $this->open_file();
        }
        if ($this->file) {
            $this->content = file_get_contents($this->path);
        }
    }

    function remove()
    {
        if (!$this->content) {
            $this->read_file();
        }
        $this->after_content = preg_replace($this->reg_comment, "", $this->content);
        return $this->content;
    }

    function compact()
    {
        if (!$this->after_content) {
            $this->remove();
        }
        $this->compact_content = preg_replace($this->reg_space, " ", $this->after_content);
        return $this->compact_content;
    }

    function compact_hightly()
    {
        if (!$this->after_content) {
            $this->remove();
        }
        $this->compact_content = preg_replace($this->reg_all_space, " ", $this->after_content);
        return $this->compact_content;
    }

    function save($file_name = "")
    {
        global $error;
        $tmp_name = date("Y-m-dHms") . "." . $this->file_info["extension"];
        $handle = "";
        if ($file_name) {
            if (!@$handle = fopen($file_name, "r")) {
                $this->halt($error[5]);
                if (!@$handle = fopen($file_name, "w")) {
                    $this->halt($error[6]);
                    return 0;
                } else {
                    @fclose($handle);
                    $this->halt($error[7]);
                }
            } else {
                @fclose($handle);
            }
        } else {
            $file_name = $tmp_name;
        }
        if ($this->compact_content) {
            $content = $this->compact_content;
        } elseif ($this->after_content) {
            $content = $this->after_content;
        }
        if (!$content) {
            $this->halt($error[8]);
            return 0;
        }
        if (@file_put_contents($file_name, $content)) {
            $this->halt("success!save as file:" . realpath($file_name));
        }
        return 1;
    }

    protected function halt($error_msg)
    {
        print printf("<h2>error : %s</h2>\n", $error_msg);
    }

    function free()
    {
        unset($this->after_content);
        unset($this->compact_content);
        unset($this->content);
        unset($this->file);
        unset($this->path);
    }
}

header("Content-type:text/html;charset:utf-8");
date_default_timezone_set("PRC");