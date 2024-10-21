export type UpdateWorkflowData = {
    resolution?: string;
    type: string;
    users: { user_id: number; user_name: string; user_role: string; user_email: string }[];
};
