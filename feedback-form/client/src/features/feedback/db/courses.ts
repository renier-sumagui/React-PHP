import axios from "axios";

export async function getCourses() {
    const result = await axios.get("http://localhost:8000/courses");

    return result.data;
}