import { useState, FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { CreateWorkflowData } from "@/Modules/Workflow/Types/CreateWorkflowData";
import { useFetchWorkflowUsers } from "./use-fetch-workflow-users";

interface IProps {
    itemParentId?: string;
}

export function useCreateWorkflow({ itemParentId }: IProps) {
    const [workflowType, setWorkflowType] = useState("reviewal");
    const users = useFetchWorkflowUsers(workflowType);
    const { closeModal } = useModalStore();

    const { data, setData, post, processing, errors, reset } = useForm<CreateWorkflowData>({
        folder_item_id: "",
        resolution: "",
        destination: "",
        type: "reviewal",
        users: []
    });

    const createApprovalSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.folder_item_id = itemParentId ?? "";
        data.users = users.map(user => ({ user_id: user.id }));

        post(route("workflows.store"), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal("workflow");
                notifications.show({
                    message: "Approval process created",
                    color: "green",
                });
            },
            onError: () => {
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return {
        data,
        setData,
        createApprovalSubmit,
        processing,
        errors,
        users,
        setWorkflowType
    };
}