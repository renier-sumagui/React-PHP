interface ApiSuccess<T> {
    success: 1;
    message: string;
    data: T;
};

interface ApiError {
    success: 0;
    message: string;
};

type ApiResponse<T> = ApiSuccess<T> | ApiError;

export type { ApiResponse };