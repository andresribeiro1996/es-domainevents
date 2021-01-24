import {Component} from "react/cjs/react.production.min";
import './EventLog.css';
export default class EventLog extends Component {
    constructor(props) {
        super(props);
    }

    // single websocket instance for the own application and constantly trying to reconnect.

    componentDidMount() {
    }


    render() {
        return (<div className="card text-white bg-dark mb-3" style={{width: "250px", height: "400px"}}>
            <div className="card-header">Console</div>
            <div className="card-body">
                <h5 className="card-title">Feed</h5>
                <p className="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>)
    }
}