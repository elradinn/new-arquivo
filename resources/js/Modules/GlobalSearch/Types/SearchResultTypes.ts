export type DocumentSearchResult = {
    id: number;
    name: string;
    document_number: string;
    metadata: {
        metadata_id: number;
        name: string;
        value: string;
    }[];
}

export type FolderSearchResult = {
    id: number;
    name: string;
    metadata: string[];
}

export type SearchResults = {
    documents: DocumentSearchResult[];
    query: string;
}