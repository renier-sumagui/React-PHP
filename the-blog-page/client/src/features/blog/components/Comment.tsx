import { useEffect, useState } from "react";
import { Reply } from "./Reply";
import { useAuth } from "../../auth/context/useAuth";
import { formatReadableDate } from "../../../utils/dateFormatter";
import { postReply } from "../api/replyApi";

import type { ReplyModel, CommentModel } from "../types/BlogModel";
import type { FormEvent } from "react";

interface CommentProps {
    comment: CommentModel;
}

function Comment({ comment }: CommentProps) {
    const [reply, setReply] = useState("");
    const { user, isLoggedIn } = useAuth();
    const [replies, setReplies] = useState<Array<ReplyModel>>([]);

    useEffect(() => {
        if (Array.isArray(comment.replies) && comment.replies.length > 0) {
            setReplies(comment.replies);
        }
    }, [comment.replies]);

    const onSubmit = async (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        if (user) {
            const res = await postReply({ userId: user.id, commentId: comment.id, content: reply });

            if (res.success) {
                setReply("");
                setReplies(state => ([...state, res.data]));
            }
        }
    };

    return (
        <div className="container-fluid px-0">
            <p className="mb-0 fw-bold">{ comment.user.firstName + " " + comment.user.lastName } ({ formatReadableDate(comment.createdAt) })</p>
            <p>{ comment.content }</p>
            { Array.isArray(replies) && replies.map((reply) => {
                return (
                    <div className="ms-5" key={reply.id}>
                        <Reply reply={reply} />
                    </div>
                )
            }) }
            { (user && isLoggedIn) && 
                <form onSubmit={onSubmit} className="ms-5 mb-3">
                    <textarea
                        name="reply" 
                        id={`${comment.id}`}
                        className="form-control mb-3 border-dark" 
                        placeholder="Write a reply..."
                        value={reply}
                        onChange={e => setReply(e.target.value)}
                    ></textarea>

                    <div className="d-flex justify-content-end">
                        <button type="submit" className="btn btn-success" disabled={reply.trim() ? false : true}>Reply</button>
                    </div>
                </form>
            }
        </div>
    )
}

export { Comment };
