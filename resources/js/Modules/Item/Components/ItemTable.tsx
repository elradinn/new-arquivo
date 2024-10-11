import { DataTable } from "mantine-datatable";
import { Group, Text } from "@mantine/core";
import ItemIcon from "./ItemIcon";

interface ItemTableProps {
    files: { data: any[] };
    openFolder: (is_folder: number, id: string) => void;
    selectedRecord: any[];
    setSelectedRecord: (records: any[]) => void;
}

export default function ItemTable({
    files,
    openFolder,
    selectedRecord,
    setSelectedRecord,
}: ItemTableProps) {

    if (!files.data.length) {
        return (
            <Text size="lg" c="gray.5">
                This folder is empty
            </Text>
        );
    }

    return (
        <DataTable
            textSelectionDisabled
            columns={[
                {
                    accessor: "name",
                    render: ({ mime, is_folder, name, approval_status }) => (
                        <Group align="center" gap={12}>
                            <ItemIcon
                                mime={mime}
                                isFolder={is_folder}
                                approvalStatus={approval_status}
                            />
                            <span>{name}</span>
                        </Group>
                    ),
                },
                { accessor: "owner" },
                {
                    accessor: "updated_at",
                    title: "Last Modified",
                },
                { accessor: "size" },
            ]}
            records={files.data}
            customRowAttributes={({ is_folder, id }) => ({
                onDoubleClick: (e: MouseEvent) => {
                    if (e.button === 0) {
                        openFolder(is_folder, id);
                    }
                },
            })}
            highlightOnHover
            horizontalSpacing="xl"
            selectedRecords={selectedRecord}
            onSelectedRecordsChange={setSelectedRecord}
        />
    );
}