import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";

interface UseDeleteFilesProps {
    setSelectedRecord: (record: any[]) => void;
}

export function useDeleteFiles({ setSelectedRecord }: UseDeleteFilesProps) {
    const { data, delete: destroy, processing } = useForm({
        ids: [],
    });

    const { closeModal } = useModalStore();

    const handleDelete = (ids: string[]) => {
        data.ids = ids as never[];

        destroy(route("item.delete"), {
            onSuccess: () => {
                closeModal("deleteFiles");
                setSelectedRecord([]);
                notifications.show({
                    message: "Files deleted",
                    color: "green",
                });
            },
            onError: (errors) => {
                let message = "Error during file deletion. Please try again later.";
                if (Object.keys(errors).length > 0) {
                    message = errors[Object.keys(errors)[0]];
                }
                notifications.show({
                    message,
                    color: "red",
                });
            },
        });
    };

    return { handleDelete, processing };
}