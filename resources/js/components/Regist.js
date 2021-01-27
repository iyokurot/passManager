import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";

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
        fetch("/code/regist",{
            method: 'POST',
            body: JSON.stringify(request),
            headers: {
                'Content-Type': 'application/json',
            },
            mode: 'cors',
        })
            .then(res => res.json())
            .then(res => {
                console.log(res);
                if(res.action != null){
                }
            });
    }
    return (
        <div>
            <h1>Regist</h1>
            <Link to="/Home">Back</Link>
            <div>
                <input placeholder='サービス名' value={serviceName} onChange={e => setServiceName(e.target.value)}/>
                <input placeholder='ID' value={idName} onChange={e => setIdName(e.target.value)}/>
                <input placeholder='mail' value={mail} onChange={e => setMail(e.target.value)}/>
                <input placeholder='password' value={password} onChange={e=>setPassword(e.target.value)}/>
                <textarea placeholder='detail' value={detail} onChange={e=>setDetail(e.target.value)}/>
                <button onClick={onClickRegistCode}>登録</button>
            </div>
            <div>{statusLog}</div>
        </div>
    );
}

export default Regist;
