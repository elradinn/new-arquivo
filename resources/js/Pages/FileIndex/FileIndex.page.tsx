import { Head, Link, router, useForm, usePage } from "@inertiajs/react";
import { FileData, PageProps } from "@/types";
import { Anchor, Breadcrumbs, Group, rem, Stack, Text } from "@mantine/core";
import { AdminLayout } from "@/Layouts/AdminLayout/AdminLayout";
import { DataTable } from "mantine-datatable";
import { IconChevronRight, IconUpload } from "@tabler/icons-react";
import { Dropzone, FileWithPath } from "@mantine/dropzone";
import { useRef, useState } from "react";
import { notifications } from "@mantine/notifications";
import FileIcon from "@/Components/FileIcon";
import Toolbar from "@/Components/Toolbar/Toolbar";

interface FormData {
    files: FileWithPath[];
    relative_path: string[];
    parent_id?: number;
}

export default function FileIndex({ auth, files, ancestors, fileData }: PageProps) {
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

    const breadcrumbItems = ancestors.data
        .slice(1) // Skip the first item
        .map((ans) => (
            <Anchor component={Link} href={`/folder/index/${ans.id}`} key={ans.id}>
                {ans.name}
            </Anchor>
        ));

    return (
        <>
            <Head title="My Files" />
            <AdminLayout
                user={auth.user}
                toolbar={
                    <Toolbar
                        fileSelected={selectedRecord.length > 0}
                        selectedIds={ids}
                        uploadFileRef={openRef}
                        page="my-files"
                        folderId={page.props.folder?.id}
                        approvalActive={fileData.has_active_workflow}
                        trackingActive={fileData.has_active_numbering}
                    />
                }
            >
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
                        <Breadcrumbs separator={<IconChevronRight size={16} />}>
                            {breadcrumbItems}
                        </Breadcrumbs>

                        {!files.data.length ? (
                            <Text size="lg" c="gray.5">
                                This folder is empty
                            </Text>
                        ) : (
                            <DataTable
                                textSelectionDisabled
                                columns={[
                                    {
                                        accessor: "name",
                                        render: ({ mime, is_folder, name, approval_status }) => (
                                            <Group align="center" gap={12}>
                                                <FileIcon
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
                                verticalSpacing="lg"
                                horizontalSpacing="xl"
                                selectedRecords={selectedRecord}
                                onSelectedRecordsChange={setSelectedRecord}
                            />
                        )}
                    </Stack>
                </Dropzone>
            </AdminLayout>
        </>
    );
}
