import { Head } from "@inertiajs/react";
import { Group, Stack, Text } from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { DataTable } from "mantine-datatable";
import { useState } from "react";
import ItemIcon from "@/Modules/Item/Components/ItemIcon";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";

export default function TrashPage({ auth, files }: any) {
    const [selectedRecord, setSelectedRecord] = useState<any[]>([]);

    const extractIds = (records: any[]): string[] => {
        return records.map((record) => record.id);
    };

    // const ids = extractIds(selectedRecord);

    // const allFiles = {
    //     data: files.data,
    // };

    return (
        <>
            <Head title="Trash" />

            {/* <Authenticated
                toolbar={
                    <Toolbar
                        fileSelected={selectedRecord.length > 0}
                        selectedIds={ids}
                        page="trash"
                    />
                }
            >
                <Head title="My Files" />

                <Stack px={8} gap={24} py={8} style={{ pointerEvents: "all" }}>
                    <Text fw={500}>Trash</Text>

                    {!allFiles.data.length ? (
                        <Text size="lg" c="gray.5">
                            This trash bin is empty
                        </Text>
                    ) : (
                        <DataTable
                            textSelectionDisabled
                            columns={[
                                {
                                    accessor: "name",
                                    render: ({ mime, is_folder, name }) => (
                                        <Group align="center" gap={12}>
                                            <ItemIcon mime={mime} isFolder={is_folder} />
                                            <span>{name}</span>
                                        </Group>
                                    ),
                                },
                                { accessor: "path" },
                            ]}
                            records={allFiles.data}
                            highlightOnHover
                            verticalSpacing="lg"
                            horizontalSpacing="xl"
                            selectedRecords={selectedRecord}
                            onSelectedRecordsChange={setSelectedRecord}
                        />
                    )}
                </Stack>
            </Authenticated> */}

            <Authenticated
                toolbar={
                    <Toolbar page="trash" />
                }
            >
                <Head title="Trash" />

                <p>Trash</p>
            </Authenticated>
        </>
    );
}