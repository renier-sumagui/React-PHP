import { useLocation } from "react-router";
import type { FeedbackFormData } from "./models/FeedbackModel";

function FeedbackResult() {
    const location = useLocation();
    let data: FeedbackFormData = location.state;

    if (!data) {
        data = {
            name: "N/A",
            track: "N/A",
            score: "N/A",
            reason: "N/A",
        }
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-6 border border-dark rounded-4">
                    <h1 className="text-center">Submitted Entry</h1>
                    <div className="container">
                        <div className="row">
                            <p className="col-sm-12 col-md-6 mb-0">Your Name (optional):</p>
                            <p className="col-sm-12 col-md-6">{ data.name }</p>
                        </div>
                        <div className="row">
                            <p className="col-sm-12 col-md-6 mb-0">Course Title:</p>
                            <p className="col-sm-12 col-md-6">{ typeof data.track === "string" ? data.track : data.track.name }</p>
                        </div>
                        <div className="row">
                            <p className="col-sm col-md-6 mb-0">Given Score (1-10):</p>
                            <p className="col-sm col-md-6">{ data.score !== "N/A" ? data.score + "pts": data.score }</p>
                        </div>
                        <div>
                            <p className="mb-0">Reason</p>
                            <p>{ data.reason  }</p>
                        </div>
                        <button type="button" className="btn btn-primary mb-3">Return</button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default FeedbackResult;