import { useRef } from "react";
import { Head, usePage } from "@inertiajs/react";
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

interface ItemPageProps {
    itemAncestors: ItemAncestorsResourceData[];
    itemContents: ItemContentsResourceData[];
}

export default function ItemPage({ itemAncestors, itemContents }: ItemPageProps) {
    // const page = usePage<PageProps>();
    const openRef = useRef<() => void>(null);
    // const { uploadFiles } = useUploadDocument(page);
    const { openFolder } = useOpenFolder();
    const { selectedRecord, setSelectedRecord, ids } = useSelectItems();

    return (
        <>
            <Head title="My Files" />

            <Authenticated>
                <ItemDropzone onDrop={() => { }} openRef={openRef}>
                    <Stack px={8} gap={24} py={8} style={{ pointerEvents: "all" }}>
                        <ItemBreadcrumbs ancestors={itemAncestors} />
                        <ItemTable
                            files={itemContents}
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
