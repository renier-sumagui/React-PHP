import { useState } from "react";
import { postComment } from "../api/commentApi";
import { useAuth } from "../../auth/context/useAuth";

import type { Dispatch, FormEvent, SetStateAction } from "react";
import type { CommentModel } from "../types/BlogModel";
import type { ApiResponse } from "../../../types/ApiResponse";

interface ReviewFormProps {
    setComments: Dispatch<SetStateAction<CommentModel[]>>;
}

function ReviewForm({ setComments }: ReviewFormProps) {
    const [review, setReview] = useState("");
    const { user } = useAuth();

    const submitHandler = async (e: FormEvent<HTMLFormElement> ) => {
        e.preventDefault();

        if (user) {
            console.log(review);
            const res: ApiResponse<CommentModel> = await postComment({ userId: user.id, content: review  });

            if (res.success) {
                console.log(res.data);

                setComments(state => (
                    [...state, res.data]
                ));
                setReview("");
                
                return;
            }
        }
    };

    return (
        <>
            <form action="#" onSubmit={submitHandler}>
                <h2><label htmlFor="review">Leave a Review</label></h2>
                <textarea 
                    name="review" 
                    id="review" 
                    className="form-control mb-3 border-dark"
                    value={review} 
                    onChange={e => setReview(e.target.value)}
                ></textarea>
                <div className="d-flex justify-content-end">
                    <button type="submit" className="btn btn-primary" disabled={review.trim() ? false : true}>Post a review</button>
                </div>
            </form>
        </>
    )
}

export { ReviewForm };