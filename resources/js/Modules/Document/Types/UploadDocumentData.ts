import { FileWithPath } from "@mantine/dropzone";

export type UploadDocumentData = {
    parent_id: string;
    name: string;
    file: FileWithPath;
};
