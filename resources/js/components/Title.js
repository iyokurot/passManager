import React, {useEffect, useState, useContext} from "react";
import ReactDOM from "react-dom";
import { Link } from "react-router-dom";
import {postServer} from "./Utils/Connection";
import Loading from "./Utils/Loading";
import './../../css/title.css'

/**
 * タイトル画面
 */
function Title(props){
    const [password, setPassword] = useState('');
    const [statusLog, setStatusLog] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    /**
     * ログイン
     */
    const onClickLogin = () =>{
        // passwordのnullチェック
        let request = {pass:password};
        setStatusLog('');
        postServer('/login',request,(res)=>{
            if(res.action != null){
                let response = res.action;
                let isLogin = response.is_login!=null ? response.is_login:false;
                let loginStatus = isLogin ? 'ログインしました':'ログインに失敗しました'
                setStatusLog(loginStatus);
                if(isLogin){
                    // Homeへ遷移
                    props.history.push('/Home');
                }
            }
        },(error)=>{
            console.log(error);
        },
            setIsLoading)
    }

    return (
        <div className="container">
            <Loading isLoading={isLoading} />
            <h1>PassManager</h1>
            {/*<Link to="/Home">Home</Link>*/}
            <div id="login-form">
                <div>
                    <p id="login-title">LOGIN</p>
                </div>
                <div>
                <input id="password-form" type="password" placeholder='password' value={password} onChange={e=>setPassword(e.target.value)}/>
                </div>
                <div>
                <button id="login-button" onClick={onClickLogin}>login</button>
                </div>
            </div>
            <div>
                <p>{statusLog}</p>
            </div>
        </div>
    );
}

export default Title;
