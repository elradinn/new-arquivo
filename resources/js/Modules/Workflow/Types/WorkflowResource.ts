export interface WorkflowResource {
    id: number;
    type: string;
    resolution: string | null;
    destination: string | null;
    users: { user_id: number; user_name: string; user_role: string; user_email: string }[];
}
