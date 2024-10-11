// @ts-nocheck
import { Head, Link, router, useForm, usePage } from "@inertiajs/react";
import { FileData, PageProps } from "@/Types";
import { rem, Stack } from "@mantine/core";
import { IconUpload } from "@tabler/icons-react";
import { Dropzone, FileWithPath } from "@mantine/dropzone";
import { useRef, useState } from "react";
import { notifications } from "@mantine/notifications";
import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";
import ItemTable from "@/Modules/Item/Components/ItemTable";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";

interface FormData {
    files: FileWithPath[];
    relative_path: string[];
    parent_id?: number;
}

export default function ItemPage({ auth, files, ancestors, fileData }: PageProps) {
    const page = usePage<PageProps>();

    const openRef = useRef<() => void>(null);

    const [selectedRecord, setSelectedRecord] = useState<FileData[]>([]);

    const extractIds = (records: FileData[]): string[] => {
        return records.map((record) => record.id);
    };

    const ids = extractIds(selectedRecord);

    const { data, post, reset, clearErrors } = useForm<FormData>({
        files: [],
        relative_path: [],
        parent_id: 0,
    });

    const openFolder = (is_folder: number, id: string) => {
        if (!is_folder) {
            return;
        }

        router.visit(route("index", { id }));
    };

    const uploadFiles = (files: FileWithPath[]) => {
        data.parent_id = page.props.folder?.id;
        data.files = files;

        data.relative_path = [...files].map((f) => f.webkitRelativePath);

        post(route("file.store"), {
            onSuccess: () => {
                notifications.show({
                    message: "File uploaded",
                    color: "green",
                });
            },
            onError: (errors) => {
                let message = "";

                if (Object.keys(errors).length > 0) {
                    message = errors[Object.keys(errors)[0]];
                } else {
                    message = "Error during file upload. Please try again later.";
                }

                notifications.show({
                    message,
                    color: "red",
                });
            },
            onFinish: () => {
                reset();
                clearErrors();
            },
        });
    };

    return (
        <>
            <Head title="My Files" />
            <Authenticated>
                <Dropzone
                    openRef={openRef}
                    onDrop={(files) => uploadFiles(files)}
                    activateOnClick={false}
                    acceptColor="var(--mantine-color-white)"
                    styles={{
                        root: {
                            border: "none",
                            padding: 0,
                        },
                    }}
                >
                    <Dropzone.Accept>
                        <IconUpload
                            style={{
                                width: rem(52),
                                height: rem(52),
                                color: "var(--mantine-color-blue-6)",
                                position: "absolute",
                                bottom: rem(16),
                                left: "50%",
                                transform: "translateX(-50%)",
                                zIndex: 9999,
                            }}
                            stroke={1.5}
                        />
                    </Dropzone.Accept>
                    <Stack px={8} gap={24} py={8} style={{ pointerEvents: "all" }}>
                        <ItemBreadcrumbs ancestors={ancestors.data} />

                        <ItemTable
                            files={files}
                            openFolder={openFolder}
                            selectedRecord={selectedRecord}
                            setSelectedRecord={setSelectedRecord}
                        />
                    </Stack>
                </Dropzone>
            </Authenticated>
        </>
    );
}
