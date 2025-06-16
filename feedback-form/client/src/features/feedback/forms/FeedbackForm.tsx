import { useForm } from "react-hook-form";
import { addFeedback } from "../db/feedback";
import { useNavigate } from "react-router";
import { useEffect, useState } from "react";
import { getCourses } from "../db/courses";

import type { SubmitHandler } from "react-hook-form";
import type { FeedbackFormData } from "../models/FeedbackModel";
import type { Course } from "../models/CourseModel";
import type { JSX } from "react";

export function FeedbackForm() {
    const navigate = useNavigate();
    const scores: JSX.Element[] = [];
    const [courses, setCourses] = useState<Course[]>([]);

    for (let num = 1; num <= 10; num++) {
        scores.push(<option key={num} value={num}>{ num }</option>);
    }

    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm<FeedbackFormData>({
        defaultValues: {
            track: "",
            score: "",
        },
    });

    const onSubmit: SubmitHandler<FeedbackFormData> = async (data) => {
        const result = await addFeedback(data);

        navigate("/result", { state: result.data });
    };

    useEffect(() => {
        (async () => {
            const result = await getCourses();

            setCourses(result.data);
        })();
    }, [])

    return (
        <form
            className="p-4 border border-dark rounded-4"
            onSubmit={handleSubmit(onSubmit)}
        >
            <h1 className="text-center mb-4">Feedback Form</h1>
            <div className="mb-3">
                <label htmlFor="name" className="form-label">
                    Your Name (optional):
                </label>
                <input
                    {...register("name")}
                    className="form-control"
                    type="text"
                    name="name"
                    id="name"
                />
            </div>
            <div className="mb-3">
                <label htmlFor="track" className="form-label">
                    Course Title:
                </label>
                <select
                    {...register("track", { required: true })}
                    className="form-select"
                    name="track"
                    id="track"
                >
                    { courses.map(course => 
                        <option key={course.id} value={course.id}>{ course.name }</option>
                    )}
                </select>
                {errors.track && (
                    <p className="form-text text-danger">Reason is required.</p>
                )}
            </div>
            <div className="mb-3">
                <label htmlFor="score" className="form-label">
                    Given Score (1-10):
                </label>
                <select
                    {...register("score", { required: true })}
                    name="score"
                    id="score"
                    className="form-select"
                    aria-label="Score"
                >
                    { scores }
                </select>
                {errors.score && (
                    <p className="form-text text-danger">Reason is required.</p>
                )}
            </div>
            <div className="mb-3">
                <label htmlFor="reason">Reason:</label>
                <textarea
                    {...register("reason", { required: true })}
                    name="reason"
                    id="reason"
                    className="form-control"
                ></textarea>
                {errors.reason && (
                    <p className="form-text text-danger">Reason is required.</p>
                )}
            </div>
            <div className="d-flex justify-content-end">
                <input
                    type="submit"
                    value="Submit"
                    className="btn btn-primary"
                />
            </div>
        </form>
    );
}
