export type ItemContentsResourceData = {
    id: string;
    owned_by?: string;
    name?: string;
    mime?: string;
    size?: string;
    type?: string;
    document_number?: string;
    status?: string;
    description?: string;
    file_path?: string;
    missing_required_metadata?: boolean; // TODO: make logic to check if the document is missing required metadata
};
