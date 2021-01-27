import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Route, Switch, Redirect } from "react-router-dom";
import Home from "./Home";
import Title from "./Title";
import Regist from "./Regist";

/**
 * ルーティング設定
 */
function Top() {
    // const token = $('meta[name="csrf-token"]').attr("content");
    return (
        <Router>
            <div>
                <Switch>
                    <Route exact path="/" component={Title} />
                    <Route path="/Home" component={Home} />
                    <Route path="/Regist" component={Regist} />
                    <Route render={() => (<Redirect to="/" />)}/>
                </Switch>
            </div>
        </Router>
    );
}

export default Top;

if (document.getElementById("reactapp")) {
    ReactDOM.render(<Top />, document.getElementById("reactapp"));
}
