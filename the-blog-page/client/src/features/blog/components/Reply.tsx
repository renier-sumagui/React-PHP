import { formatReadableDate } from "../../../utils/dateFormatter";
import type { ReplyModel } from "../types/BlogModel";

interface ReplyInterface {
    reply: ReplyModel;
}

function Reply({ reply }: ReplyInterface) {
    return (
        <div className="container-fluid px-0">
            <p className="mb-0 fw-bold">{ reply.user.firstName + " " + reply.user.lastName } ({ formatReadableDate(reply.createdAt) })</p>
            <p>{ reply.content }</p>
        </div>
    )
}

export { Reply };