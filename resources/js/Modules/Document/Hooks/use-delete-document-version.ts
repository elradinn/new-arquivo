import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";

export default function useDeleteDocumentVersion() {
    const { delete: deleteRequest, processing } = useForm();

    const deleteVersion = (versionId: string) => {
        deleteRequest(route("document.delete_version", { version: versionId }), {
            onSuccess: () => {
                notifications.show({
                    message: "Document version deleted successfully.",
                    color: "green",
                });
            },
            onError: () => {
                notifications.show({
                    message: "Failed to delete document version.",
                    color: "red",
                });
            },
        });
    };

    return { deleteVersion, processing };
}