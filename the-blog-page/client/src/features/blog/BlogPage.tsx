import { useState, useEffect } from "react";
import { ReviewForm } from "./components/ReviewForm";
import { Comment } from "./components/Comment";
import { useAuth } from "../auth/context/useAuth";
import { getAllComments } from "./api/commentApi";

import type { CommentModel, GetAllCommentsResponse } from "./types/BlogModel";

function BlogPage() {
    const { user, isLoggedIn } = useAuth();

    const [comments, setComments] = useState<Array<CommentModel>>([]);

    useEffect(() => {
        async function getComments() {
            const res: GetAllCommentsResponse = await getAllComments();

            if (res.success && res.data.length > 0) {
                setComments(res.data);
            }
        }

        getComments();
    }, []);

    return (
        <div className="container-fluid">
            <h1>Title</h1>
            <p className="mb-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam labore, libero aliquam itaque sequi, ab repellat blanditiis quas eos fugiat aliquid ullam fugit sunt laudantium sit voluptate tempore cupiditate rem.</p>
            {(user && isLoggedIn) && 
                <div className="mb-4">
                    <ReviewForm setComments={setComments} />
                </div>
            }
            <div>
                <h2>Comments</h2>
                { Array.isArray(comments) && comments.map((comment) => {
                    return <Comment key={comment.id} comment={comment} />
                })}
            </div>
        </div>
    )
}

export default BlogPage;