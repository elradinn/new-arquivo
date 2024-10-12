import React from "react";
import { ActionIcon, Box, Group } from "@mantine/core";
import { DataTable } from "mantine-datatable";
import { IconEdit, IconTrash } from "@tabler/icons-react";
import { MetadataResourceData } from "../Types/MetadataResourceData";

interface MetadataTableProps {
    metadata: MetadataResourceData[];
    // total: number;
    // perPage: number;
    // page: number;
    // onPageChange: (page: number) => void;
    onEdit: (metadata: MetadataResourceData) => void;
    onDelete: (metadata: MetadataResourceData) => void;
    selectedRecords: MetadataResourceData[];
    onSelectedRecordsChange: (records: MetadataResourceData[]) => void;
}

const MetadataTable: React.FC<MetadataTableProps> = ({
    metadata,
    // total,
    // perPage,
    // page,
    // onPageChange,
    onEdit,
    onDelete,
    selectedRecords,
    onSelectedRecordsChange,
}) => {
    return (
        <DataTable
            pinLastColumn
            withTableBorder
            shadow="xs"
            borderRadius="sm"
            withRowBorders={false}
            highlightOnHover
            verticalSpacing="md"
            // totalRecords={total}
            // recordsPerPage={perPage}
            // page={page}
            // onPageChange={onPageChange}
            columns={[
                { accessor: "name", noWrap: true },
                { accessor: "description", noWrap: true },
                { accessor: "type", noWrap: true },
                {
                    accessor: "actions",
                    title: <Box mr={6}>Actions</Box>,
                    textAlign: "right",
                    render: (metadata) => (
                        <Group gap={8} justify="right" wrap="nowrap">
                            <ActionIcon
                                size="sm"
                                variant="subtle"
                                color="gray"
                                onClick={() => onEdit(metadata)}
                            >
                                <IconEdit size={48} />
                            </ActionIcon>
                            <ActionIcon
                                size="sm"
                                variant="subtle"
                                color="red"
                                onClick={() => onDelete(metadata)}
                            >
                                <IconTrash size={48} />
                            </ActionIcon>
                        </Group>
                    ),
                },
            ]}
            records={metadata}
            selectedRecords={selectedRecords}
            onSelectedRecordsChange={onSelectedRecordsChange}
        />
    );
};

export default MetadataTable;