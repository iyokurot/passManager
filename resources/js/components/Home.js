import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";

/**
 * ホーム画面
 */
function Home(props) {
    const [passList, setPassList] = useState([]);
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
            });
    }, []);

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
    return (
        <div>
            <h1>Home</h1>
            <Link to="/Regist">Regist</Link>
            <button onClick={onClickLogout}>ログアウト</button>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>サービス名</th>
                        <th>ID</th>
                        <th>メール</th>
                        <th>パス</th>
                    </tr>
                    </thead>
                    <tbody>
            {passList.map((pass, index) => (
                <tr key={index}>
                    <td>{pass.service_name}</td>
                    <td>{pass.id_name}</td>
                    <td>{pass.mail}</td>
                    <td>{pass.password}</td>
                </tr>
            ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}

export default Home;
