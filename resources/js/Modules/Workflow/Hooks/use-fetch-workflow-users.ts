import axios from "axios";
import { useState, useEffect } from "react";
import { UserResourceData } from "@/Modules/User/Types/UserResourceData";

export function useFetchWorkflowUsers(workflowType: string) {
    const [users, setUsers] = useState<UserResourceData[]>([]);

    useEffect(() => {
        if (workflowType) {
            fetchUsers(workflowType);
        }
    }, [workflowType]);

    const fetchUsers = async (type: string) => {
        try {
            const response = await axios.get(`/workflows/api/users-by-workflow-type?type=${type}`);
            setUsers(response.data);
        } catch (error) {
            console.error("Error fetching users", error);
        }
    };

    return users;
}