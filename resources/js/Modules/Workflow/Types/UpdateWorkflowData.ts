import { UserResourceData } from "@/Modules/User/Types/UserResourceData";

export type UpdateWorkflowData = {
    resolution?: string;
    type: string;
    users: UserResourceData[];
};
