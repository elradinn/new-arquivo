import { useRef } from "react";
import { Head } from "@inertiajs/react";
import { Stack } from "@mantine/core";
import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";
import ItemTable from "@/Modules/Item/Components/ItemTable";
import ItemDropzone from "@/Modules/Item/Components/ItemDropzone";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { useUploadDocument } from "@/Modules/Document/Hooks/use-upload-document";
import { useOpenFolder } from "@/Modules/Item/Hooks/use-open-folder";
import { useSelectItems } from "@/Modules/Item/Hooks/use-select-items";
import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";
import { ItemContentsResourceData } from "@/Modules/Item/Types/ItemContentsResourceData";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";
interface ItemPageProps {
    itemParent: ItemParentResourceData;
    itemAncestors: ItemAncestorsResourceData[];
    itemContents: ItemContentsResourceData[];
}

export default function ItemPage({ itemParent, itemAncestors, itemContents }: ItemPageProps) {
    const openRef = useRef<() => void>(null);
    const { uploadFiles } = useUploadDocument(itemParent);
    const { openFolder } = useOpenFolder();
    const { selectedRecord, setSelectedRecord, ids } = useSelectItems();

    console.log(itemAncestors);

    return (
        <>
            <Head title="My Files" />

            <Authenticated toolbar={<Toolbar page="item" itemParent={itemParent} />}>
                <ItemDropzone onDrop={uploadFiles} openRef={openRef}>
                    <Stack px={8} gap={24} py={8} style={{ pointerEvents: "all" }}>
                        <ItemBreadcrumbs ancestors={itemAncestors} />
                        <ItemTable
                            itemContents={itemContents}
                            openFolder={openFolder}
                            selectedRecord={selectedRecord}
                            setSelectedRecord={setSelectedRecord}
                        />
                    </Stack>
                </ItemDropzone>
            </Authenticated>
        </>
    );
}
