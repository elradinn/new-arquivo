import { useEffect } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { MetadataResourceData } from "../Types/MetadataResourceData";
import { UpdateMetadataData } from "../Types/UpdateMetadataData";

interface IProps {
    metadata?: MetadataResourceData;
    close: () => void;
}

export function useUpdateMetadata({ metadata, close }: IProps) {
    const { data, setData, patch, processing, errors, reset } = useForm<UpdateMetadataData>({
        name: "",
        type: "",
    });

    useEffect(() => {
        if (metadata) {
            setData({
                name: metadata.name,
                type: metadata.type,
            });
        }
    }, [metadata]);

    const handleEdit = (e: React.FormEvent) => {
        e.preventDefault();

        patch(route("metadata.update", metadata?.id), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Metadata edited successfully",
                    color: "green",
                });
            },
            onFinish: () => reset(),
        });
    };

    return { data, setData, handleEdit, processing, errors };
}