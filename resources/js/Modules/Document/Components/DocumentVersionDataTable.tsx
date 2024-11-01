import React from "react";
import { DataTable } from "mantine-datatable";
import { ActionIcon, Button, Group, Text } from "@mantine/core";
import { IconDownload, IconTrash, IconRefresh } from "@tabler/icons-react";
import { DocumentVersionResourceData } from "../Types/DocumentVersionResourceData";
import useRestoreDocumentVersion from "../Hooks/use-restore-document-version";
import useDeleteDocumentVersion from "../Hooks/use-delete-document-version";

interface DocumentVersionsDataTableProps {
    versions: DocumentVersionResourceData[];
}

const DocumentVersionsDataTable: React.FC<DocumentVersionsDataTableProps> = ({ versions }) => {
    const { restoreVersion } = useRestoreDocumentVersion();
    const { deleteVersion } = useDeleteDocumentVersion();

    return (
        <DataTable
            columns={[
                { accessor: "name", title: "Name" },
                { accessor: "uploaded_at", title: "Uploaded At" },
                {
                    accessor: "actions",
                    title: "Actions",
                    render: (record: DocumentVersionResourceData) => (
                        <Group gap={4}>
                            <ActionIcon
                                variant="subtle"
                                onClick={() => restoreVersion(record.id)}
                            >
                                <IconRefresh size={16} />
                            </ActionIcon>
                            <ActionIcon
                                variant="subtle"
                                color="red"
                                onClick={() => deleteVersion(record.id)}
                            >
                                <IconTrash size={16} />
                            </ActionIcon>
                            <a href={record.file_path} download>
                                <ActionIcon
                                    variant="subtle"
                                >
                                    <IconDownload size={16} />
                                </ActionIcon>
                            </a>
                        </Group>
                    ),
                },
            ]}
            records={versions}
            highlightOnHover
            verticalSpacing="sm"
            horizontalSpacing="sm"
        />
    );
};

export default DocumentVersionsDataTable;