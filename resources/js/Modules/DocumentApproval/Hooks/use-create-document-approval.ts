import { useState, FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { useFetchUsersApprovalRole } from "@/Modules/Common/Hooks/use-fetch-users-approval-role";
import { CreateDocumentApprovalData } from "../Types/CreateDocumentApprovalData";

interface IProps {
    documentId?: string;
}

export function useCreateDocumentApproval({ documentId }: IProps) {
    const [documentApprovalType, setDocumentApprovalType] = useState("reviewal");
    const { closeModal, modals } = useModalStore();
    const users = useFetchUsersApprovalRole(documentApprovalType, modals["createDocumentApproval"]);

    const { data, setData, post, processing, errors, reset } = useForm<CreateDocumentApprovalData>({
        document_id: "",
        resolution: "",
        destination: "",
        type: "reviewal",
        users: []
    });

    const createApprovalSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.document_id = documentId ?? "";
        data.users = users.map(user => ({ user_id: user.id.toString() }));

        post(route("document_approvals.store"), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal("createDocumentApproval");
                notifications.show({
                    message: "Document approval process created",
                    color: "green",
                });
            },
            onError: (errors) => {
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
        setDocumentApprovalType
    };
}