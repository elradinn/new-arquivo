export type DocumentResourceData = {
    item_id: string;
    name: string;
    document_number?: string;
    status?: string;
    description?: string;
    file_path?: string;
    related_documents: Array<{
        item_id: string;
        name: string;
    }>;
    metadata: Array<{
        name: string;
        value: string;
    }>;
    created_at: string;
    updated_at: string;
};
