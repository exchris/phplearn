<?php
/**
 * 错误码类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 下午 7:12
 */
class ErrorCode {
	const SUCCESS = 0; // 正确
    const USERNAME_EXISTS = 40001; //用户名已经存在
    const PASSWORD_CANNOT_EMPTY = 40002; //密码不能为空
    const USERNAME_CANNOT_EMPTY = 40003; //用户名不能为空
    const REGISTER_FAIL = 40004; //注册失败
    const USER_INVALID = 40005; // 非法用户
    const USERNAME_INVALID =  2; //用户名不存在
    const PASSWORD_INVALID = 3; // 密码错误
    const AVATAR_MUST_SETTING = 7; //头像未设置
    const NICKNAME_CANNOT_EMPTY = 8; //昵称不能为空
    const PASSWORD_LENGTH_SETTING = 40009; //密码长度6-20位
    const USERNAME_OR_PASSWORD_INVALID = 40010; //用户名或密码错误
    const UPDATE_PASSWORD_FAIL = 40011; // 修改密码失败
    const USERNAME_FLAG = 40012; // 用户标识
    
    // 短信验证信息
    const MOBILE_CANNOT_EMPTY = 40020; // 手机号码不能为空
    const EMAIL_CANNOT_EMPTY = 40021;  // 邮箱不能为空
    const MOBILE_INVALID = 40022;  // 手机不合法
    const CODE_INVALID = 40023; // 验证码错误
    const CODE_TIMEOUT = 40025; // 验证码超时
    const EMAIL_INVALID = 40024;  // 邮箱不合法
    const MESSAGE_FAIL = 40026; // 短信发送失败
    const CODE_NOT_FOUND = 40027; // 验证码未获取
    

    CONST SERVER_INTERNAL_ERROR = 15; //服务器内部错误
}

