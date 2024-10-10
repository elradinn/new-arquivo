import { Dropzone, FileWithPath } from "@mantine/dropzone";
import { notifications } from "@mantine/notifications";
import { useForm } from "@inertiajs/react";

const FileUpload = ({ onUploadSuccess }) => {
    const { data, post, reset } = useForm({
        files: [],
        relative_path: [],
        parent_id: 0,
    });

    const uploadFiles = (files: FileWithPath[]) => {
        data.files = files;
        data.relative_path = files.map((f) => f.webkitRelativePath);

        post(route("file.store"), {
            onSuccess: () => {
                notifications.show({ message: "File uploaded", color: "green" });
                onUploadSuccess();
            },
            onError: (errors) => {
                notifications.show({ message: "Error during file upload", color: "red" });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Dropzone onDrop={uploadFiles}>
            {/* Dropzone content */}
        </Dropzone>
    );
};

export default FileUpload;