import { DataTable } from "mantine-datatable";
import { Group, Text } from "@mantine/core";
import ItemIcon from "./ItemIcon";
import { ItemContentsResourceData } from "../Types/ItemContentsResourceData";

interface ItemTableProps {
    itemContents: ItemContentsResourceData[];
    openFolder: (type: string, id: string) => void;
    selectedRecord: ItemContentsResourceData[];
    setSelectedRecord: (records: ItemContentsResourceData[]) => void;
}

const ItemTable: React.FC<ItemTableProps> = ({
    itemContents,
    openFolder,
    selectedRecord,
    setSelectedRecord,
}) => {
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
                // onDoubleClick: (e: MouseEvent) => {
                //     if (e.button === 0) {
                //         openFolder(type, id);
                //     }
                // },
            })}
            highlightOnHover
            horizontalSpacing="xl"
            selectedRecords={selectedRecord}
            onSelectedRecordsChange={setSelectedRecord}
        />
    );
}

export default ItemTable;

// import { Link } from "@inertiajs/react";
// import { Anchor, Breadcrumbs, Group } from "@mantine/core";
// import { IconChevronRight } from "@tabler/icons-react";
// import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";
// import { ItemContentsResourceData } from "../Types/ItemContentsResourceData";
// import { DataTable } from "mantine-datatable";

// interface ItemTableProps {
//     itemContents: ItemContentsResourceData[];
//     openFolder: (is_folder: number, id: string) => void;
//     selectedRecord: any[];
//     setSelectedRecord: (records: any[]) => void;
// }

// export default function ItemTable({ itemContents }: BreadcrumbProps) {

//     const table = (
//         <DataTable
//         textSelectionDisabled
//         columns={[
//             {
//                 accessor: "name",
//                 render: ({ mime, is_folder, name, approval_status }) => (
//                     <Group align="center" gap={12}>
//                         <ItemIcon
//                             mime={mime}
//                             isFolder={is_folder}
//                             approvalStatus={approval_status}
//                         />
//                         <span>{name}</span>
//                     </Group>
//                 ),
//             },
//             { accessor: "owner" },
//             {
//                 accessor: "updated_at",
//                 title: "Last Modified",
//             },
//             { accessor: "size" },
//         ]}
//         records={itemContents}
//         customRowAttributes={({ is_folder, id }) => ({
//             onDoubleClick: (e: MouseEvent) => {
//                 if (e.button === 0) {
//                     openFolder(is_folder, id);
//                 }
//             },
//         })}
//         highlightOnHover
//         horizontalSpacing="xl"
//         selectedRecords={selectedRecord}
//         onSelectedRecordsChange={setSelectedRecord}
//     />
//     )

//     return (
//         <Breadcrumbs separator={<IconChevronRight size={16} />}>
//             {breadcrumbItems}
//         </Breadcrumbs>
//     );
// }