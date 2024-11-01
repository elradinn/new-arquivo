import React from 'react';
import { DataTable } from 'mantine-datatable';
import { Stack, Text } from '@mantine/core';
import { IconFolder, IconFile } from '@tabler/icons-react';
import { SearchResults, DocumentSearchResult, FolderSearchResult } from '@/Modules/GlobalSearch/Types/SearchResultTypes';
import { Authenticated } from '@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated';

interface Props {
    documents: DocumentSearchResult[];
    // folders: FolderSearchResult[];
    query: string;
}

const SearchItemsResult: React.FC<Props> = ({ documents, query }) => {
    // Combine documents and folders into a single list with a type field
    const combinedResults = [
        ...documents.map(doc => ({ ...doc, type: 'document' as const })),
        // ...folders.map(folder => ({ ...folder, type: 'folder' as const })),
    ];

    return (
        <Authenticated>
            <Stack px={8} py={8} gap={24}>
                <Text component="h2" size="xl" fw={600} color="gray.8">
                    Search Results for "{query}"
                </Text>

                <DataTable
                    columns={[
                        {
                            accessor: 'type', title: 'Type', render: (record: any) => (
                                record.type === 'document' ? <IconFile size={20} /> : <IconFolder size={20} />
                            )
                        },
                        { accessor: 'name', title: 'Name' },
                        { accessor: 'document_number', title: 'Document Number', hidden: true },
                        // { accessor: 'metadata', title: 'Metadata', render: (metadata: any[]) => metadata.map((meta: any) => `${meta.name}: ${meta.value}`).join(', ') },
                    ]}
                    records={combinedResults}
                // page={1}
                // recordsPerPage={10}
                // paginationText={({ from, to, total }) => `${from} - ${to} of ${total}`}
                />
            </Stack>
        </Authenticated>
    );
};

export default SearchItemsResult;