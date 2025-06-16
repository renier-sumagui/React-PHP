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

type GetAllCommentsSuccess = {
    success: 1;
    message: string;
    data: Array<CommentModel>;
};

type GetAllCommentsFail = {
    success: 0;
    message: string;
};

type CreateCommentSuccess = {
    success: 1;
    message: string;
    data: CommentModel;
};

type CreateCommentFailure = {
    success: 0;
    message: string;
};

type CreateReplyData = {
    userId: number;
    commentId: number;
    content: string;
};

type CreateReplySuccess = {
    success: 1,
    message: string;
    data: ReplyModel;
};

type CreateReplyFailure = {
    success: 0;
    message: string;
};

type CreateReplyResponse = CreateReplySuccess | CreateReplyFailure;

type CreateCommentResponse = CreateCommentSuccess | CreateCommentFailure;

type GetAllCommentsResponse = GetAllCommentsSuccess | GetAllCommentsFail;

export type { CommentModel, ReplyModel, CreateCommentData, GetAllCommentsResponse, CreateCommentResponse, CreateReplyData, CreateReplyResponse };