import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { UpdateDocumentApprovalData } from "../Types/UpdateDocumentApprovalData";
import { useFetchUsersApprovalRole } from "@/Modules/Common/Hooks/use-fetch-users-approval-role";
import { useEffect, useState } from "react";
import { useFetchDocumentApproval } from "./use-fetch-document-approval";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";

interface IProps {
    documentApprovalId?: string;
    isOpen: boolean;
}

export function useUpdateDocumentApproval({ documentApprovalId, isOpen }: IProps) {
    const [documentApprovalType, setDocumentApprovalType] = useState("reviewal");
    const documentApproval = useFetchDocumentApproval({
        documentApprovalId,
        isOpen,
    });
    const fetchedUsers = useFetchUsersApprovalRole(documentApprovalType, isOpen);
    const { closeModal } = useModalStore();

    const { data, setData, put, processing, errors, reset, clearErrors } =
        useForm<UpdateDocumentApprovalData>({
            resolution: "",
            type: "",
            users: [],
        });

    useEffect(() => {
        setData({
            resolution: documentApproval?.resolution || "",
            type: documentApproval?.type || "",
            users: (documentApproval?.document_user_approvals || []).map((user) => ({
                user_id: user.user_id,
            })),
        });
        setDocumentApprovalType(documentApproval?.type || "");
    }, [documentApproval]);

    const handleClose = () => {
        closeModal("updateDocumentApproval");
        reset();
        clearErrors();
    };

    const handleUpdateDocumentApproval = (e: React.FormEvent) => {
        e.preventDefault();

        data.users = fetchedUsers.map((user) => ({ user_id: user.id.toString() }));

        put(route("document_approvals.update", documentApprovalId), {
            onSuccess: () => {
                handleClose();
                notifications.show({
                    message: "Document approval updated successfully",
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
        handleUpdateDocumentApproval,
        processing,
        errors,
        handleClose,
        fetchedUsers,
        setDocumentApprovalType,
        documentApproval,
    };
}