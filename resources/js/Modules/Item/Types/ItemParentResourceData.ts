import { FolderRequiredMetadataResource } from "@/Modules/Folder/Types/FolderRequiredMetadataResource";

export type ItemParentResourceData = {
    item_id: string;
    name: string;
    owned_by: string;
    numbering_scheme_id?: number;
    workflow_id?: number;
    required_metadata?: FolderRequiredMetadataResource[];
};