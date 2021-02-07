import React, { useEffect, useState, useContext } from "react";
import { Link } from "react-router-dom";
import {postServer} from "./Utils/Connection";
import Loading from "./Utils/Loading";
import './../../css/home.css'

/**
 * ホーム画面
 */
function Home(props) {
    const [reload,setReload] = useState(0);
    const [statusLog, setStatusLog] = useState('');
    const [passList, setPassList] = useState([]);
    const [selectCode, setSelectCode] = useState({});
    const [isOpenModal, setIsOpenModal] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    useEffect(() => {
        // pass の全取得
        postServer('code/getall',null,
            (res) => {
                if(res.action != null){
                    let passList = res.action.code_list;
                    setPassList(passList);
                    setIsLoading(false);
                }else if(res.error != null){
                    setStatusLog('エラーが発生しました')
                }else{
                    props.history.push('/');
                }
            },
            (error) => {
                props.history.push('/');
            },
            setIsLoading)
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
        postServer('logout',null,
            (res) => {
                setStatusLog('ログアウトしました')
                props.history.push('/');
            },
            (error) => {
            setStatusLog('エラーが発生しました')
            },
            setIsLoading)
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

    const onClickRegistPage = ()=>{
        props.history.push('/Regist');
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
                },
                setIsLoading)
        }
        setIsOpenModal(false);
    }
    return (
        <div className="container">
            <Loading isLoading={isLoading}/>
            <h1>Home</h1>
            {/*<Link to="/Regist">Regist</Link>*/}
            <div>
            <button onClick={onClickRegistPage}>Regist</button>
            <button onClick={onClickLogout}>ログアウト</button>
            </div>
            <div>{statusLog}</div>
            <div>
                <div id="table-area">
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
                </div>

            </div>
            {isOpenModal ?
                <div className="regist-area" id="detail-area">
                    <div className="input-area"><p className="input-title">サービス名</p><input placeholder='サービス名' value={selectCode.service_name} onChange={e => onChangeCode('service_name',e.target.value)}/></div>
                    <div className="input-area"><p className="input-title">ID</p><input placeholder='ID' value={selectCode.id_name} onChange={e => onChangeCode('id_name',e.target.value)}/></div>
                    <div className="input-area"><p className="input-title">mail</p><input placeholder='mail' value={selectCode.mail} onChange={e => onChangeCode('mail',e.target.value)}/></div>
                    <div className="input-area"><p className="input-title">password</p><input placeholder='password' value={selectCode.password} onChange={e => onChangeCode('password',e.target.value)}/></div>
                    <div className="input-area"><p className="input-title">detail</p><textarea placeholder='detail' value={selectCode.detail} onChange={e => onChangeCode('detail',e.target.value)}/></div>
                    <div>
                        <button onClick={() => closeOrSaveModal(false)}>閉じる</button>
                        <button onClick={() => closeOrSaveModal(true)}>保存</button>
                    </div>
                </div>:''}
        </div>
    );
}

export default Home;
