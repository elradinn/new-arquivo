// import {
//     ActionIcon,
//     Button,
//     Group,
//     Modal,
//     Stack,
//     Text,
//     TextInput,
//     Box,
// } from "@mantine/core";
// import { DataTable } from "mantine-datatable";
// import { IconTrash, IconEdit, IconPlus } from "@tabler/icons-react";
// import { useState } from "react";
// import { FolderRequiredMetadataResource } from "@/Modules/Folder/Types/FolderRequiredMetadataResource";
// import useFetchMetadata from "@/Modules/Metadata/Hooks/use-fetch-metadata";
// import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
// import { Head } from "@inertiajs/react";

// interface FolderMetadataProps {
//     requiredMetadata: FolderRequiredMetadataResource[];
//     folder: {
//         item_id: string;
//         name: string;
//     };
// }

// export default function FolderMetadataPage({ requiredMetadata, folder }: FolderMetadataProps) {
//     const [opened, setOpened] = useState(false);
//     const [selectedMetadata, setSelectedMetadata] = useState<number | null>(null);
//     const { metadataList } = useFetchMetadata();

//     // const handleAddMetadata = () => {
//     //     if (selectedMetadata) {
//     //         Inertia.post(route('folder.updateRequiredMetadata'), {
//     //             folder_item_id: folder.item_id,
//     //             metadata_id: selectedMetadata,
//     //         });
//     //         setOpened(false);
//     //         setSelectedMetadata(null);
//     //     }
//     // };

//     const handleDelete = (metadata_id: number) => {
//         // Implement delete functionality if required
//     };

//     return (
//         <Authenticated>
//             <Head title="Required Metadata" />

//             <Stack gap={24} p={8}>
//                 <Group justify="space-between">
//                     <Text component="h2" size="xl" fw={600} c="gray.8">
//                         Required Metadata for {folder.name}
//                     </Text>

//                     <Button leftSection={<IconPlus size={16} />} onClick={() => setOpened(true)}>
//                         Add Required Metadata
//                     </Button>
//                 </Group>

//                 <DataTable
//                     columns={[
//                         { accessor: "name", title: "Name" },
//                         { accessor: "description", title: "Description" },
//                         {
//                             accessor: "actions",
//                             title: "Actions",
//                             render: (metadata) => (
//                                 <Group gap="xs">
//                                     <ActionIcon color="red" onClick={() => handleDelete(metadata.metadata_id)}>
//                                         <IconTrash size={16} />
//                                     </ActionIcon>
//                                 </Group>
//                             ),
//                         },
//                     ]}
//                     records={requiredMetadata}
//                     withTableBorder
//                     borderRadius="sm"
//                     highlightOnHover
//                     striped
//                 />

//                 <Modal opened={opened} onClose={() => setOpened(false)} title="Add Required Metadata">
//                     <Stack gap={16}>
//                         <TextInput
//                             label="Select Metadata"
//                             placeholder="Choose metadata"
//                             onChange={(e) => setSelectedMetadata(parseInt(e.target.value))}
//                             list="metadata-list"
//                         />
//                         <datalist id="metadata-list">
//                             {metadataList.map((meta) => (
//                                 <option key={meta.metadata_id} value={meta.metadata_id}>
//                                     {meta.name}
//                                 </option>
//                             ))}
//                         </datalist>
//                         <Group justify="flex-end">
//                             <Button variant="outline" onClick={() => setOpened(false)}>
//                                 Cancel
//                             </Button>
//                             <Button onClick={() => { }} disabled={!selectedMetadata}>
//                                 Add
//                             </Button>
//                         </Group>
//                     </Stack>
//                 </Modal>
//             </Stack>
//         </Authenticated >
//     );
// }

import {
    ActionIcon,
    Button,
    Group,
    Stack,
    Text,
} from "@mantine/core";
import { DataTable } from "mantine-datatable";
import { IconTrash, IconPlus } from "@tabler/icons-react";
import { useState } from "react";
import { FolderRequiredMetadataResource } from "@/Modules/Folder/Types/FolderRequiredMetadataResource";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { Head } from "@inertiajs/react";
import AddRequiredMetadataModal from "@/Modules/Folder/Forms/AddRequiredMetadataModal";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { useAddRequiredMetadata } from "@/Modules/Folder/Hooks/use-add-required-metadata";

interface FolderMetadataProps {
    requiredMetadata: FolderRequiredMetadataResource[];
    folder: {
        item_id: string;
        name: string;
    };
}

export default function FolderMetadataPage({ requiredMetadata, folder }: FolderMetadataProps) {
    const { openModal, closeModal } = useModalStore();
    const { handleAddMetadata } = useAddRequiredMetadata({
        folderId: folder.item_id,
        close: () => closeModal("addRequiredMetadata"),
    });

    const handleDelete = (metadata_id: number) => {
        // Implement delete functionality if required
    };

    return (
        <Authenticated>
            <Head title="Required Metadata" />

            <Stack gap={24} p={8}>
                <Group justify="space-between">
                    <Text component="h2" size="xl" fw={600} c="gray.8">
                        Required Metadata for {folder.name}
                    </Text>

                    <Button leftSection={<IconPlus size={16} />} onClick={() => openModal("addRequiredMetadata")}>
                        Add Required Metadata
                    </Button>
                </Group>

                <DataTable
                    columns={[
                        { accessor: "name", title: "Name" },
                        { accessor: "description", title: "Description" },
                        {
                            accessor: "actions",
                            title: "Actions",
                            render: (metadata) => (
                                <Group gap="xs">
                                    <ActionIcon color="red" onClick={() => handleDelete(metadata.id)}>
                                        <IconTrash size={16} />
                                    </ActionIcon>
                                </Group>
                            ),
                        },
                    ]}
                    records={requiredMetadata}
                    withTableBorder
                    borderRadius="sm"
                    highlightOnHover
                    striped
                />

                <AddRequiredMetadataModal folderId={folder.item_id} onAdd={handleAddMetadata} />
            </Stack>
        </Authenticated>
    );
}