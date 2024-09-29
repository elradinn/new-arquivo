import { useForm } from "@inertiajs/react";

export function useDeleteAllDocuments() {
    const { delete: destroy, processing } = useForm();

    const deleteAll = () => {
        destroy("/documents");
    };

    return { deleteAll, processing };
}