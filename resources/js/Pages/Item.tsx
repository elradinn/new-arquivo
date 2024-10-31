import { useRef } from "react";
import { Head } from "@inertiajs/react";
import { Group, Stack, Text } from "@mantine/core";
import { DataTable, DataTableColumn } from "mantine-datatable";

import { ItemIcon } from "@/Modules/Common/Components/ItemIcon/ItemIcon";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";

import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";
import ItemDropzone from "@/Modules/Item/Components/ItemDropzone";
import ItemToolbar from "@/Modules/Item/Components/ItemToolbar";
import SelectedItemToolbar from "@/Modules/Item/Components/ItemSelectedToolbar";

import { useUploadDocument } from "@/Modules/Document/Hooks/use-upload-document";
import { useSelectItems } from "@/Modules/Item/Hooks/use-select-items";
import { useDocumentProperties } from "@/Modules/Item/Hooks/use-document-properties";
import { useOpenFolder } from "@/Modules/Item/Hooks/use-open-folder";

import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";
import { ItemContentsResourceData } from "@/Modules/Item/Types/ItemContentsResourceData";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";
import SelectMetadataColumnForm from "@/Modules/Common/Components/SelectMetadataColumn/SelectMetadataColumnForm";

interface ItemPageProps {
    itemParent: ItemParentResourceData;
    itemAncestors: ItemAncestorsResourceData[];
    itemContents: ItemContentsResourceData[];
}

export default function ItemPage({ itemParent, itemAncestors, itemContents }: ItemPageProps) {
    const openRef = useRef<() => void>(null);
    const { uploadFiles } = useUploadDocument(itemParent);
    const { selectedRecord, setSelectedRecord, ids } = useSelectItems();
    const { openFolder } = useOpenFolder();
    const { openDocument } = useDocumentProperties();

    const dynamicColumns = itemParent.metadata_columns?.map((metadata) => ({
        accessor: `metadata_${metadata.id}`,
        title: metadata.name,
        render: (record: ItemContentsResourceData) => {
            const metadataItem = record.metadata?.find((m) => m.id === metadata.id);
            return metadataItem ? metadataItem.value : null;
        },
    }));

    console.log(itemContents);

    const metadataColumns: DataTableColumn<ItemContentsResourceData>[] = [
        {
            accessor: "name",
            render: ({ mime, type, name, status, missing_required_metadata }) => (
                <Group align="center" gap={12}>
                    <ItemIcon
                        mime={mime ?? ""}
                        isFolder={type === "folder"}
                        approvalStatus={status}
                        missingRequiredMetadata={missing_required_metadata}
                    />
                    <span>{name}</span>
                </Group>
            ),
        },
        {
            accessor: "updated_at",
            title: "Last Modified",
        },
        ...(dynamicColumns ?? []),
    ];

    return (
        <>
            <Head title="My Files" />

            <Authenticated
                toolbar={
                    selectedRecord.length > 0 ? (
                        <SelectedItemToolbar setSelectedRecord={setSelectedRecord} selectedIds={ids} parentId={itemParent.item_id} />
                    ) : (
                        <ItemToolbar
                            itemParent={itemParent}
                            uploadFileRef={openRef}
                        />
                    )
                }>
                <ItemDropzone onDrop={uploadFiles} openRef={openRef}>
                    <Stack px={8} gap={24} py={8} style={{ pointerEvents: "all" }}>
                        <ItemBreadcrumbs ancestors={itemAncestors} />

                        {!itemContents.length ? (
                            <Text size="lg" c="gray.5">
                                This folder is empty
                            </Text>
                        ) : (
                            <DataTable
                                textSelectionDisabled
                                columns={metadataColumns}
                                // columns={[
                                //     {
                                //         accessor: "name",
                                //         render: ({ mime, type, name, status, missing_required_metadata }) => (
                                //             <Group align="center" gap={12}>
                                //                 <ItemIcon
                                //                     mime={mime ?? ""}
                                //                     isFolder={type === "folder"}
                                //                     approvalStatus={status}
                                //                     missingRequiredMetadata={missing_required_metadata}
                                //                 />
                                //                 <span>{name}</span>
                                //             </Group>
                                //         ),
                                //     },
                                //     { accessor: "owner" },
                                //     {
                                //         accessor: "updated_at",
                                //         title: "Last Modified",
                                //     },
                                //     { accessor: "size" },
                                // ]}
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
                        )}
                    </Stack>
                </ItemDropzone>
            </Authenticated>

            <SelectMetadataColumnForm folderId={itemParent.item_id} />
        </>
    );
}
