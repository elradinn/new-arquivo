export type DocumentResourceData = {
    item_id: string;
    name: string;
    document_number?: string;
    status?: string;
    description?: string;
    file_path?: string;
    document_approval_id?: string;
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
