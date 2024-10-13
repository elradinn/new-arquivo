import { DataTable } from "mantine-datatable";
import { Group, Text } from "@mantine/core";
import ItemIcon from "./ItemIcon";
import { ItemContentsResourceData } from "../Types/ItemContentsResourceData";
import { useOpenFolder } from "../Hooks/use-open-folder";
import { useDocumentProperties } from "../Hooks/use-document-properties";

interface ItemTableProps {
    itemContents: ItemContentsResourceData[];
    selectedRecord: ItemContentsResourceData[];
    setSelectedRecord: (records: ItemContentsResourceData[]) => void;
}

const ItemTable: React.FC<ItemTableProps> = ({
    itemContents,
    selectedRecord,
    setSelectedRecord,
}) => {
    const { openFolder } = useOpenFolder();
    const { openDocument } = useDocumentProperties();

    if (!itemContents.length) {
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
                    render: ({ mime, type, name, status }) => (
                        <Group align="center" gap={12}>
                            <ItemIcon
                                mime={mime ?? ""}
                                isFolder={type === "folder"}
                                approvalStatus={status}
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
            records={itemContents}
            customRowAttributes={({ type, id }) => ({
                onDoubleClick: (e: MouseEvent) => {
                    if (e.button === 0) {
                        // TODO: Simplify this
                        if (type === "folder") {
                            openFolder(type, id);
                        } else if (type === "document") {
                            openDocument(type, id);
                        }
                    }
                },
            })}
            highlightOnHover
            verticalSpacing="lg"
            horizontalSpacing="xl"
            selectedRecords={selectedRecord}
            onSelectedRecordsChange={setSelectedRecord}
        />
    );
}

export default ItemTable;
