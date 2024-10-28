import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { UpdateFolderMetadataData } from "../Types/UpdateFolderMetadataData";
import useFetchMetadata from "@/Modules/Metadata/Hooks/use-fetch-metadata";

interface IProps {
    folderId: string;
    close: () => void;
}

export function useAddRequiredMetadata({ folderId, close }: IProps) {
    const { data, setData, post, processing, errors, reset } = useForm<UpdateFolderMetadataData>({
        metadata_id: 0,
    });

    const handleAddMetadata = (metadataId: number) => {
        data.metadata_id = metadataId;

        console.log(data);

        post(route("folder.updateRequiredMetadata", folderId), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Metadata added successfully",
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

    return { handleAddMetadata, processing, errors };
}