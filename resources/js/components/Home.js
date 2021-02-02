import React, { useEffect, useState, useContext } from "react";
import { Link } from "react-router-dom";
import {postServer} from "./Utils/Connection";

/**
 * ホーム画面
 */
function Home(props) {
    const [reload,setReload] = useState(0);
    const [statusLog, setStatusLog] = useState('');
    const [passList, setPassList] = useState([]);
    const [selectCode, setSelectCode] = useState({});
    const [isOpenModal, setIsOpenModal] = useState(false);
    useEffect(() => {
        // pass の全取得
        fetch("/code/getall")
            .then(res => res.json())
            .then(res => {
                console.log(res);
                if(res.action != null){
                    let passList = res.action.code_list;
                    setPassList(passList);
                }else if(res.error != null){
                    //
                }else{
                    props.history.push('/');
                }
            })
            .catch(error => {
                props.history.push('/');
            });
    }, [reload]);

    /**
     * ログアウト
     */
    const onClickLogout = () =>{
        fetch('logout')
            .then(res => res.json())
            .then(res => {
                props.history.push('/');
            })
    }

    /**
     * CODE編集
     * @param index
     */
    const onClickCode = (index) => {
        let tmpArray = Object.assign({},passList[index]);
        setSelectCode(tmpArray);
        setIsOpenModal(true);
    }

    /**
     * CODE変更
     * @param key
     * @param value
     */
    const onChangeCode = (key,value) => {
        let tmpCode = Object.assign({},selectCode);
        tmpCode[key] = value;
        setSelectCode(tmpCode);
    }

    const closeOrSaveModal = (isSave) => {
        if(isSave){
            // Codeの更新処理
            let body = {
                code_id:selectCode.id,
                service_name:selectCode.service_name,
                id_name:selectCode.id_name,
                password:selectCode.password,
                mail:selectCode.mail,
                detail:selectCode.detail
            }
            postServer('code/update',body,
                (res)=>{
                //更新
                    setStatusLog(selectCode.service_name +'の情報を更新しました')
                    setReload(reload + 1);
                },
                (error) => {
                // error
                    setStatusLog('エラーが発生しました');
                })
        }
        setIsOpenModal(false);
    }
    return (
        <div>
            <h1>Home</h1>
            <Link to="/Regist">Regist</Link>
            <button onClick={onClickLogout}>ログアウト</button>
            <div>{statusLog}</div>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>サービス名</th>
                        <th>ID</th>
                        <th>メール</th>
                        <th>パス</th>
                        <th>詳細</th>
                    </tr>
                    </thead>
                    <tbody>
            {passList.map((pass, index) => (
                <tr key={index}>
                    <td>{pass.service_name}</td>
                    <td>{pass.id_name}</td>
                    <td>{pass.mail}</td>
                    <td>{pass.password}</td>
                    <td><button onClick={()=>onClickCode(index)}>詳細</button></td>
                </tr>
            ))}
                    </tbody>
                </table>

                {isOpenModal ?
                    <div>
                        {/*<div>{selectCode.service_name}</div>*/}
                        {/*<div>{selectCode.id_name}</div>*/}
                        {/*<div>{selectCode.mail}</div>*/}
                        {/*<div>{selectCode.password}</div>*/}
                        <div><input placeholder='サービス名' value={selectCode.service_name} onChange={e => onChangeCode('service_name',e.target.value)}/></div>
                        <div><input placeholder='ID' value={selectCode.id_name} onChange={e => onChangeCode('id_name',e.target.value)}/></div>
                        <div><input placeholder='mail' value={selectCode.mail} onChange={e => onChangeCode('mail',e.target.value)}/></div>
                        <div><input placeholder='password' value={selectCode.password} onChange={e => onChangeCode('password',e.target.value)}/></div>
                        <div><textarea placeholder='detail' value={selectCode.detail} onChange={e => onChangeCode('detail',e.target.value)}/></div>
                        <div>
                        <button onClick={() => closeOrSaveModal(false)}>閉じる</button>
                        <button onClick={() => closeOrSaveModal(true)}>保存</button>
                        </div>
                    </div>:''}

            </div>
        </div>
    );
}

export default Home;
