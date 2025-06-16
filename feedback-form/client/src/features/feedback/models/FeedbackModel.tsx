export type FeedbackFormData = {
  name: string;
  track: { 
        id: string | number,
        name: string, 
        created_at: string,
        updated_at: string
    } | string;
  score: string;
  reason: string;
}