import { format, parse } from "date-fns"

function formatReadableDate(raw: string): string {
    const parseDate = parse(raw, "yyyy-MM-dd HH:mm:ss", new Date());

    return format(parseDate, "MMMM do yyyy h:mma");
}

export { formatReadableDate };