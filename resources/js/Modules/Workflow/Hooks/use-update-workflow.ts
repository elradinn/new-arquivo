import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { UpdateWorkflowData } from "../Types/UpdateWorkflowData";
import { useFetchWorkflowUsers } from "./use-fetch-workflow-users";
import { useEffect } from "react";
import { useFetchWorkflow } from "./use-fetch-workflow";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";

interface IProps {
    itemParent?: ItemParentResourceData;
    isOpen: boolean;
}

export function useUpdateWorkflow({ itemParent, isOpen }: IProps) {
    const workflow = useFetchWorkflow({ workflowId: itemParent?.workflow_id, isOpen });

    console.log("Where is the workflow?", workflow);

    const { data, setData, put, processing, errors, reset, clearErrors } = useForm<UpdateWorkflowData>({
        resolution: "",
        type: "",
        users: [],
    });

    const users = useFetchWorkflowUsers(data.type);

    const { closeModal } = useModalStore();

    useEffect(() => {
        setData({
            resolution: workflow?.resolution || "",
            type: workflow?.type || "",
            users: workflow?.users || [],
        });
    }, [workflow]);

    const handleClose = () => {
        closeModal("updateWorkflow");
        reset();
        clearErrors();
    };

    const handleUpdateWorkflow = (e: React.FormEvent) => {
        e.preventDefault();

        put(route("workflows.update", itemParent?.workflow_id), {
            onSuccess: () => {
                handleClose();
                notifications.show({
                    message: "Workflow updated successfully",
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

    return { data, setData, handleUpdateWorkflow, processing, errors, handleClose, users };
}