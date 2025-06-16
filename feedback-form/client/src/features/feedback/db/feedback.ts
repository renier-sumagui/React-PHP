import axios from "axios";
import type { FeedbackFormData } from "../models/FeedbackModel";

export async function addFeedback(data: FeedbackFormData) {
    const { name, track, score, reason } = data;

    const result = await axios.post('http://localhost:8000/feedback', {
        name,
        track,
        score,
        reason
    });

    return result.data;
}