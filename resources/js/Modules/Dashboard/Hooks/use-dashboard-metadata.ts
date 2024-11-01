// resources/js/Modules/Dashboard/Hooks/useDashboardMetadata.ts
import { useForm } from "@inertiajs/react";
import { DashboardMetadataResourceData } from "../Types/DashboardMetadataResourceData";
import { notifications } from "@mantine/notifications";

interface UseDashboardMetadataProps {
    folderId: string;
    closeModal: () => void;
}

export function useDashboardMetadata({ folderId, closeModal }: UseDashboardMetadataProps) {
    const { data, setData, post, processing, errors, reset } = useForm({
        metadata_ids: [] as number[],
    });

    const handleSubmit = () => {
        post(route("dashboard.selectMetadataColumn", folderId), {
            onSuccess: () => {
                notifications.show({
                    title: "Success",
                    message: "Metadata columns updated successfully",
                    color: "green",
                });
                closeModal();
                reset();
            },
            onError: () => {
                notifications.show({
                    title: "Error",
                    message: "Failed to update metadata columns",
                    color: "red",
                });
            },
        });
    };

    return {
        data,
        setData,
        handleSubmit,
        processing,
        errors,
    };
}