import { FolderRequiredMetadataResource } from "@/Modules/Folder/Types/FolderRequiredMetadataResource";
import { DocumentMetadata } from "./DocumentMetadata";

export type DocumentResourceData = {
    item_id: string;
    name: string;
    document_number?: string;
    status?: string;
    description?: string;
    file_path?: string;
    document_approval_id?: string;
    related_documents: Array<{
        id: string;
        item_id: string;
        name: string;
    }>;
    metadata: DocumentMetadata[];
    required_folder_metadata: FolderRequiredMetadataResource[];
    created_at: string;
    updated_at: string;
};
