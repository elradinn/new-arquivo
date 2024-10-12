import { PageProps } from "@/types";
import { useForm, usePage } from "@inertiajs/react";
import {
    Button,
    Flex,
    Group,
    Modal,
    Radio,
    Stack,
    Text,
    Textarea,
    TextInput,
} from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { IconListTree } from "@tabler/icons-react";
import React, { FormEventHandler } from "react";

interface IFormProps {
    isOpened: boolean;
    close: () => void;
}

interface FormData {
    file_id?: string;
    name: string;
    scheme: string;
}

const ApprovalForm: React.FC<IFormProps> = ({ isOpened, close }) => {
    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        file_id: "",
        name: "",
        scheme: "",
    });

    const parent_id = usePage<PageProps>().props.folder?.id;

    const createFolderSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.file_id = parent_id.toString();

        post(route("numbering-scheme.store"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Numbering scheme created",
                    color: "green",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Create Document Numbering
                </Text>
            }
            size={550}
        >
            <form onSubmit={createFolderSubmit}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        You can set up a numbering scheme for files in this folder.
                    </Text>
                    <Radio.Group name="status" defaultValue="active">
                        <Group mt="xs">
                            <Radio value="active" label="Active" />
                            <Radio value="inactive" label="Inactive" />
                        </Group>
                    </Radio.Group>

                    <TextInput
                        id="numbering_name"
                        type="text"
                        name="numbering_name"
                        label="Numbering Name"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />

                    <Textarea
                        label="Scheme"
                        autosize
                        minRows={2}
                        maxRows={4}
                        value={data.scheme}
                        onChange={(e) => setData("scheme", e.target.value)}
                        error={errors.scheme}
                    />

                    <TextInput id="preview" type="text" name="preview" label="Preview" readOnly />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Create
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

interface TrackingButtonProps {
    trackingActive?: boolean;
}

const TrackingButton: React.FC<TrackingButtonProps> = ({ trackingActive }) => {
    const [createApprovalOpened, { open: openCreateApproval, close: closeCreateApproval }] =
        useDisclosure(false);

    return (
        <>
            <Button
                variant={trackingActive ? "light" : "subtle"}
                color={trackingActive ? "green.8" : "dark.3"}
                leftSection={<IconListTree size={18} />}
                onClick={openCreateApproval}
            >
                Tracking
            </Button>

            <ApprovalForm isOpened={createApprovalOpened} close={closeCreateApproval} />
        </>
    );
};

export default TrackingButton;
