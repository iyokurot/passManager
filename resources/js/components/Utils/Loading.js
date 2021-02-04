import React, {useState, useEffect} from "react";
import './../../../css/loading.css';

function Loading(props) {
    // const [isLoading,setIsLoading] = useState(true);
    // useEffect(() => {
    //     setIsLoading(props.isLoading);
    // }, []);
    return (
        <div id={props.isLoading?"cover-show":"cover"}>
            <div id="loading-area">
                <div id="loading-component">
                    NOW LOADING ...
                </div>
            </div>
        </div>
    );
}

export default Loading;

