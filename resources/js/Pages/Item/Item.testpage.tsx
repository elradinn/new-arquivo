// @ts-nocheck
import { useRef, useState } from "react";
import { Head, usePage, router } from "@inertiajs/react";
import { Stack } from "@mantine/core";
import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";
import ItemTable from "@/Modules/Item/Components/ItemTable";
import ItemDropzone from "@/Modules/Item/Components/ItemDropzone";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { useUploadDocument } from "@/Modules/Document/Hooks/use-upload-document";
import { useOpenFolder } from "@/Modules/Item/Hooks/use-open-folder";
import { useSelectItems } from "@/Modules/Item/Hooks/use-select-items";

export default function ItemPage({ auth, files, ancestors, fileData }: PageProps) {
    const page = usePage<PageProps>();
    const openRef = useRef<() => void>(null);
    const { uploadFiles } = useUploadDocument(page);
    const { openFolder } = useOpenFolder();
    const { selectedRecord, setSelectedRecord, ids } = useSelectItems();

    return (
        <>
            <Head title="My Files" />

            <Authenticated>
                <ItemDropzone onDrop={uploadFiles} openRef={openRef}>
                    <Stack px={8} gap={24} py={8} style={{ pointerEvents: "all" }}>
                        <ItemBreadcrumbs ancestors={ancestors.data} />
                        <ItemTable
                            files={files}
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
