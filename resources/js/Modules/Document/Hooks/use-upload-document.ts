import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { FileWithPath } from "@mantine/dropzone";

interface FormData {
    files: FileWithPath[];
    relative_path: string[];
    parent_id?: number;
}

export function useUploadDocument(page: any) {
    const { data, post, reset, clearErrors } = useForm<FormData>({
        files: [],
        relative_path: [],
        parent_id: 0,
    });

    const uploadFiles = (files: FileWithPath[]) => {
        data.parent_id = page.props.folder?.id;
        data.files = files;
        data.relative_path = [...files].map((f) => f.webkitRelativePath);

        post(route("file.store"), {
            onSuccess: () => {
                notifications.show({
                    message: "File uploaded",
                    color: "green",
                });
            },
            onError: (errors) => {
                let message = "";

                if (Object.keys(errors).length > 0) {
                    message = errors[Object.keys(errors)[0]];
                } else {
                    message = "Error during file upload. Please try again later.";
                }

                notifications.show({
                    message,
                    color: "red",
                });
            },
            onFinish: () => {
                reset();
                clearErrors();
            },
        });
    };

    return { uploadFiles };
}