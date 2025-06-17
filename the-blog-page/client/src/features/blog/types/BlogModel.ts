type User = {
    firstName: string;
    lastName: string;
};

type ReplyModel = {
    id: number;
    name: string;
    content: string;
    user: User;
    createdAt: string;
    updatedAt: string;
};

type CommentModel = { 
    id: number;
    content: string;
    replies: Array<ReplyModel> | null;
    user: User;
    createdAt: string;
    updatedAt: string;
};

type CreateCommentData = {
    userId: number;
    content: string;
};

type CreateReplyData = {
    userId: number;
    commentId: number;
    content: string;
};

export type { CommentModel, ReplyModel, CreateCommentData, CreateReplyData };