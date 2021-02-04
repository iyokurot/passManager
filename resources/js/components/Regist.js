import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import {postServer} from "./Utils/Connection";
import Loading from "./Utils/Loading";
import './../../css/regist.css'

/**
 * 登録画面
 */
function Regist(props) {
    const [serviceName, setServiceName] = useState('');
    const [idName, setIdName] = useState('');
    const [mail, setMail] = useState('');
    const [password, setPassword] = useState('');
    const [detail, setDetail] = useState('');
    const [statusLog, setStatusLog] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    const onClickRegistCode = () =>{
        // 空白チェック
        let request =
            {
                service_name:serviceName,
                id_name:idName,
                password:password,
                mail:mail,
                detail:detail
            };
        postServer('/code/regist',request,
            (res)=>{
            if(res.action != null){
                setStatusLog(serviceName +"を登録しました")
                setServiceName('')
                setIdName('')
                setMail('')
                setPassword('')
                setDetail('')
            }else if(res.error != null){
                // 吉のエラー
                setStatusLog('エラーが発生しました。コード['+res.error.code + ']('+res.error.message+')')
            }
            },
            (error) => {
            setStatusLog('エラーがはっせいしました')
            },
            setIsLoading)
    }

    /**
     * ホームに戻るボタン
     */
    const onClickBackHome = () => {
        props.history.push('/Home')
    }
    return (
        <div className="container">
            <Loading isLoading={isLoading}/>
            <h1>Regist</h1>
            <div>
                <button onClick={onClickBackHome}>Back</button>
            </div>
            <div className="regist-area">
                <div>
                    <input className="input-area" placeholder='サービス名' value={serviceName} onChange={e => setServiceName(e.target.value)}/>
                </div>
                <div>
                    <input className="input-area" placeholder='ID' value={idName} onChange={e => setIdName(e.target.value)}/>
                </div>
                <div>
                    <input className="input-area" placeholder='mail' value={mail} onChange={e => setMail(e.target.value)}/>
                </div>
                <div>
                    <input className="input-area" placeholder='password' type="password" value={password} onChange={e=>setPassword(e.target.value)}/>
                </div>
                <div>
                    <textarea className="input-area" placeholder='detail' value={detail} onChange={e=>setDetail(e.target.value)}/>
                </div>
                <div>
                    <button onClick={onClickRegistCode}>登録</button>
                </div>
            </div>
            <div>{statusLog}</div>
        </div>
    );
}

export default Regist;
