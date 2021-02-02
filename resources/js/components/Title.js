import React, {useEffect, useState, useContext} from "react";
import ReactDOM from "react-dom";
import { Link } from "react-router-dom";
import {postServer} from "./Utils/Connection";

/**
 * タイトル画面
 */
function Title(props){
    const [password, setPassword] = useState('');
    const [statusLog, setStatusLog] = useState('');

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
        })
    }

    return (
        <div className="container">
            <h1>PassManager</h1>
            <Link to="/Home">Home</Link>
            <div>
                <input placeholder='password' value={password} onChange={e=>setPassword(e.target.value)}/>
                <button onClick={onClickLogin}>login</button>
            </div>
            <div>
                <p>{statusLog}</p>
            </div>
        </div>
    );
}

export default Title;
